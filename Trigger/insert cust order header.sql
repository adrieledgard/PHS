delimiter //
create trigger trginsertcustorder after insert on cust_order_detail
for each row
begin
 declare done int(2); 
 declare Var_Id_variation int(11); 
 declare Var_Qty int(11);  
 declare Var_stock_atc_awal int(11);

 set Var_Id_variation   = new.Id_variation;
 
 set Var_stock_atc_awal = (select Stock_atc from variation_product where Id_variation = Var_Id_variation);
 set Var_Qty   = new.Qty + Var_stock_atc_awal;
 
 
 update variation_product set Stock_atc = Var_Qty where Id_variation = Var_Id_variation;
  

end;//