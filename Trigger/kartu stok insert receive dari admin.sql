delimiter //
create trigger trgreceiveheader_2 after insert on receive_expire
for each row
begin
 declare done   int(2); 
 declare Var_No_receive varchar(20);
 declare Var_tgl date; 
 declare Var_Id_product int(11); 
 declare Var_Id_variation int(11); 
 declare Var_Expire_date date; 
 declare Var_No_reference varchar(20); 
 declare Var_First_stock int(11); 
 declare Var_Debet int(11); 
 declare Var_Last_stock int(11); 
 declare Var_Transaction_price int(11); 
 declare Var_Capital int(11); 
 declare Var_Fifo_stock int(11); 
 declare Var_Stokawal int(11);
 declare Var_Stokakhir int(11);
  declare Var_Status int(11);
 

 set Var_Status = (SELECT Status FROM receive_header WHERE No_receive = (SELECT No_receive FROM receive_detail WHERE No_receive_detail= new.No_receive_detail));



 if Var_Status = 2 then 
	
 set Var_tgl = (SELECT receive_date FROM receive_header WHERE No_receive = (SELECT No_receive FROM receive_detail WHERE No_receive_detail= new.No_receive_detail));
 set Var_Id_product   = new.Id_product;
 set Var_Id_variation   = new.Id_variation;
 set Var_Expire_date    = new.Expire_date;
 set Var_Debet     = new.Qty;
 
 
 
 set Var_Stokawal = (select stock from variation_product where Id_variation = Var_Id_variation);
  set Var_Stokakhir  = Var_Stokawal + Var_Debet;
  
  
  
 set Var_No_reference = new.No_receive_expire;
 set Var_First_stock  = (SELECT IFNULL(Last_stock,Var_Stokawal) FROM stock_card WHERE Id_variation = Var_Id_variation order by Id_stock_card desc limit 1); 
 set Var_Last_stock = ifnull(Var_First_stock,Var_Stokawal) + Var_Debet;
 set Var_Transaction_price = (SELECT purchase_price FROM receive_detail WHERE No_receive_detail = new.No_receive_detail);
 set Var_Capital = Var_Transaction_price;
 set Var_Fifo_stock= Var_Debet;
 
 update variation_product set Purchase_price = Var_Transaction_price where Id_variation = Var_Id_variation;
  
  
  update variation_product set stock =  Var_Stokakhir where id_variation = Var_Id_variation;
  
  
   insert into stock_card
    (Id_stock_card, Date_card, Id_product, Id_variation, Expire_date, Type_card, No_reference, First_stock, Debet, Credit, Last_stock, Transaction_price, Capital, Fifo_stock)
    values
  (null, Var_tgl, Var_Id_product, Var_Id_variation , Var_Expire_date, 'Purchase', Var_No_reference, ifnull(Var_First_stock,Var_Stokawal), Var_Debet, 0, ifnull(Var_Last_stock,0), Var_Transaction_price, Var_Capital, Var_Fifo_stock);
   
 end if;
end;//