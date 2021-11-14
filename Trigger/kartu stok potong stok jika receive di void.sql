delimiter //
create trigger trgreceiveheader_void after update on receive_header
for each row
begin
 declare done int(2); 
 declare done2 int(2); 
 declare Var_No_receive varchar(20);
 declare Var_tgl date; 
 declare Var_Id_product int(11); 
 declare Var_Id_variation int(11); 
 declare Var_Expire_date date; 
 declare Var_No_reference varchar(20); 
 declare Var_First_stock int(11); 
 declare Var_Debet int(11); 
 declare Var_Debet_2 int(11); 
 declare Var_Temp_Debet int(11); 
 declare Var_Last_stock int(11); 
 declare Var_Transaction_price int(11); 
 declare Var_Capital int(11); 
 declare Var_Fifo_stock int(11); 
 declare Var_Stokawal int(11);
 declare Var_Stokakhir int(11);
 
 declare Var2_Id_stock_card int(11);
 declare Var2_Id_product int(11);
  declare Var2_Id_variation int(11);
  declare Var2_Expire_date date;
  declare Var2_Fifo_stock int(11);
  declare Var2_Temp_Debet int(11);
 
 
 
 
   declare receive_expire cursor for 
   select 
   receive_detail.No_receive, 
   receive_detail.Purchase_price, 
   receive_expire.No_receive_expire,
   receive_expire.Id_product, 
   receive_expire.Id_variation, 
   receive_expire.Qty, 
   receive_expire.Expire_date 
   from receive_expire, receive_detail where receive_expire.No_receive_detail = receive_detail.No_receive_detail and receive_detail.No_receive = old.No_receive;
   declare continue HANDLER for not found set done = 1;
   
 if old.Status = 2 and new.Status = 0 then 
 BLOCK1: BEGIN
   set done   = 0;
   
   open receive_expire;
   read_loop: loop
     Fetch receive_expire into Var_No_receive,Var_Transaction_price,Var_No_reference, Var_Id_product, Var_Id_variation, Var_Debet, Var_Expire_date;
     if done = 1 then
      leave read_loop;
     else 
  
	  set Var_Stokawal = (select stock from variation_product where Id_variation = Var_Id_variation);
	  set Var_Stokakhir  = Var_Stokawal - Var_Debet;
	  update variation_product set Stock =  Var_Stokakhir where Id_variation = Var_Id_variation;
		
	  
		
		
		BLOCK2: BEGIN
		declare stock_card cursor for 
		select 
		stock_card.Id_stock_card,
		stock_card.Id_product,
		stock_card.Id_variation,
		stock_card.Expire_date,
		stock_card.Fifo_stock
		from stock_card where stock_card.Id_variation = Var_Id_variation and stock_card.Fifo_stock>0 and Var_Expire_date >= stock_card.Expire_date order by stock_card.Expire_date asc;
		declare continue HANDLER for not found set done2 = 1;
			set Var_Debet_2 = Var_Debet;
			
		  open stock_card;
		   read_loop: loop
			 Fetch stock_card into Var2_Id_stock_card ,Var2_Id_product,Var2_Id_variation,Var2_Expire_date, Var2_Fifo_stock;
			 if done2 = 1 then
			  leave read_loop;
			 else 
			 
			 set Var2_Temp_Debet = Var_Debet_2 - Var2_Fifo_stock;
			 
			 
				 if Var2_Temp_Debet=0 then
					  update stock_card set Fifo_stock = 0 where Id_stock_card = Var2_Id_stock_card;
					
					done2 = 1;
				 elseif Var2_Temp_Debet<0 then
				  update stock_card set Fifo_stock = (Var2_Temp_Debet*-1) where Id_stock_card = Var2_Id_stock_card;
					
					done2 = 1;
				
				 else
					update stock_card set Fifo_stock = 0 where Id_stock_card = Var2_Id_stock_card;
					set Var_Debet_2 = Var_Debet_2-Var2_Fifo_stock;
				 
				 
				 
				 end if;
			 
			 
			 end if;
		   end loop; 
		   close stock_card;			 
					 
		END BLOCK2;
     end if;
   end loop; 
   close receive_expire;
   END BLOCK1;
   
 end if; 
end;//