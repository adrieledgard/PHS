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
   
 if old.Status = 1 and new.Status = 2 then 
   set done   = 0;
   
   open receive_expire;
   read_loop: loop
     Fetch receive_expire into Var_No_receive,Var_Transaction_price,Var_No_reference, Var_Id_product, Var_Id_variation, Var_Debet, Var_Expire_date;
     if done = 1 then
      leave read_loop;
     else 
  
  update variation_product set Purchase_price = Var_Transaction_price where Id_variation = Var_Id_variation;
  
  set Var_Stokawal = (select stock from variation_product where Id_variation = Var_Id_variation);
  set Var_Stokakhir  = Var_Stokawal + Var_Debet;
  update variation_product set Stock =  Var_Stokakhir where Id_variation = Var_Id_variation;
  
  
  
  set Var_tgl = (SELECT receive_date FROM receive_header WHERE No_receive = Var_No_receive);
  set Var_First_stock  = (SELECT IFNULL(Last_stock,Var_Stokawal) FROM stock_card WHERE Id_variation = Var_Id_variation order by Id_stock_card desc limit 1); 
  set Var_Last_stock = ifnull(Var_First_stock,Var_Stokawal) + Var_Debet;
  set Var_Capital = Var_Transaction_price;
  set Var_Fifo_stock= Var_Debet;
  
  
  
  
 insert into dummy(tesint,tesstring)
  values(ifnull(Var_First_stock,Var_Stokawal),Var_tgl);
  
  
  
   insert into stock_card
    (Id_stock_card, Date_card, Id_product, Id_variation, Expire_date, Type_card, No_reference, First_stock, Debet, Credit, Last_stock, Transaction_price, Capital, Fifo_stock)
    values
  (null, Var_tgl, Var_Id_product, Var_Id_variation , Var_Expire_date, 'Purchase', Var_No_reference, ifnull(Var_First_stock,Var_Stokawal), Var_Debet, 0, ifnull(Var_Last_stock,0), Var_Transaction_price, Var_Capital, Var_Fifo_stock);
   
 
     
     end if;
   end loop; 
   close receive_expire;
   
   
 end if; 
end