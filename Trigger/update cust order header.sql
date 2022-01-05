delimiter //
create trigger trgupdatecustorder after update on cust_order_header
for each row
begin
 declare done   int(2); 
 declare done2 int(2); 
 declare qty_temp int(11);
 declare stock_atc_awal int(11);
 declare stock_awal int(11);
 declare Var_Id_detail_order int(11);
 declare Var_Id_order int(11);
 declare Var_Id_product int(11);
 declare Var_Id_variation int(11);
 declare Var_Qty int(11);
 declare Var_Normal_price int(11);
 declare Var_Id_promo int(11);
 declare Var_Discount_promo int(11);
 declare Var_Fix_price int(11);
 declare Var_No_reference varchar(20); 
 declare Var_tgl date; 
 
 declare Var2_Id_stock_card int(11);
declare Var2_Id_product int(11);
declare Var2_Id_variation int(11);
declare Var2_Expire_date date;
declare Var2_Fifo_stock int(11);
declare Var2_Temp_Debet int(11);
 declare Var2_First_stock int(11); 
  declare Var2_Capital int(11); 
declare pengurangan int(11);
 
 
  declare Var_Qty_2 int(11); 
 
 
   declare cust_order_detail cursor for 
   select 
   Id_detail_order, 
   Id_order, 
   Id_product,
   Id_variation,
   Qty, 
   Normal_price, 
   Id_promo, 
   Discount_promo,
   Fix_price
   from cust_order_detail where Id_order = old.Id_order;
   declare continue HANDLER for not found set done = 1;
   
   
   
   
 if old.Status = 1 and new.Status = 2 then 
  BLOCK1: BEGIN
  
  
		   set done   = 0;
		   
		   open cust_order_detail;
		   read_loop: loop
			 Fetch cust_order_detail into Var_Id_detail_order,Var_Id_order,Var_Id_product, Var_Id_variation, Var_Qty, Var_Normal_price, Var_Id_promo, Var_Discount_promo, Var_Fix_price;
			 if done = 1 then
			  leave read_loop;
			 else 
		  
					 
					 
				set stock_atc_awal = (select Stock_atc from variation_product where Id_variation = Var_Id_variation);
				set stock_awal = (select Stock from variation_product where Id_variation = Var_Id_variation);
				
				update variation_product set Stock_atc = (stock_atc_awal - Var_Qty) where Id_variation = Var_Id_variation;
				update variation_product set Stock = (stock_awal - Var_Qty) where Id_variation = Var_Id_variation;
				
				 BLOCK2: BEGIN
					declare stock_card cursor for 
					select 
					stock_card.Id_stock_card,
					stock_card.Id_product,
					stock_card.Id_variation,
					stock_card.Expire_date,
					stock_card.Fifo_stock,
					stock_card.Capital
					from stock_card where stock_card.Id_variation = Var_Id_variation and stock_card.Fifo_stock>0 order by stock_card.Expire_date asc;
					declare continue HANDLER for not found set done2 = 1;
					
					set done2 = 0;
					set Var_Qty_2 = Var_Qty;
					
					
					open stock_card;
					 read_loop2: loop
					Fetch stock_card into Var2_Id_stock_card ,Var2_Id_product,Var2_Id_variation,Var2_Expire_date, Var2_Fifo_stock, Var2_Capital;
					if done2 = 1 then
					 leave read_loop2;
					else 
						  insert into dummy values(Var2_Fifo_stock,'Var2_Fifo_stock');
						  insert into dummy values(Var_Qty_2,'Var_Qty_2');
						  
						  
						  
						if Var2_Fifo_stock >= Var_Qty_2 then 
						  update stock_card set Fifo_stock = Fifo_stock - Var_Qty_2 where Id_stock_card = Var2_Id_stock_card;
						
						  set pengurangan = Var_Qty_2;
						  set done2 = 1;
						  
						else 
						  update stock_card set Fifo_stock = 0 where Id_stock_card = Var2_Id_stock_card;
						  set Var_Qty_2 = Var_Qty_2 - Var2_Fifo_stock;
						  set pengurangan = Var2_Fifo_stock;
						end if;
						
					set Var2_First_stock  = (SELECT Last_stock FROM stock_card WHERE Id_variation = Var2_Id_variation order by Id_stock_card desc limit 1); 
					
					set Var_tgl = now();
					
					
					insert into stock_card
					(Id_stock_card, Date_card, Id_product, Id_variation, Expire_date, Type_card, No_reference, First_stock, Debet, Credit, Last_stock, Transaction_price, Capital, Fifo_stock)
					values
				  (null, Var_tgl, Var2_Id_product, Var2_Id_variation , Var2_Expire_date, CONCAT('Cust_order - ',Var2_Id_stock_card), Var_Id_detail_order, Var2_First_stock, 0, pengurangan, ifnull(Var2_First_stock-pengurangan,0), Var_Fix_price, Var2_Capital, 0);
				   
					  
					
					end if;
				 end loop read_loop2; 
				 close stock_card;  
				 END BLOCK2;
			  
			 
			 end if;
		   end loop; 
		   close cust_order_detail;
   
   
  END BLOCK1;
  elseif old.Status = 1 and new.Status = 0 then 
  
  
	   set done   = 0;
	   
	   open cust_order_detail;
	   read_loop: loop
		 Fetch cust_order_detail into Var_Id_detail_order,Var_Id_order,Var_Id_product, Var_Id_variation, Var_Qty, Var_Normal_price, Var_Id_promo, Var_Discount_promo, Var_Fix_price;
		 if done = 1 then
		  leave read_loop;
		 else 
	  
				 
				 
			set stock_atc_awal = (select Stock_atc from variation_product where Id_variation = Var_Id_variation);
			
			update variation_product set Stock_atc = (stock_atc_awal - Var_Qty) where Id_variation = Var_Id_variation;
			
			 
		  
		 
		 end if;
	   end loop; 
	   close cust_order_detail;

   
  
 end if; 
end;//