<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
            @php
                echo session()->get('userlogin')->Username; 
                echo "<br>";
                echo "( " .session()->get('userlogin')->Role ." )";
                // echo $siapa;
            @endphp
            {{-- Alexander Pierce --}}
          
          </a>
        
        </div>
        <a href="{!! url('logout_team_member'); !!}">
          {{ Form::button('Logout',['class'=>'btn btn-sm btn-primary float-right','name'=>'btn_add']) }}
          {{-- <button class="btn btn-primary"><i class="fa fa-plus"></i> Insert</button> --}}
        </a>
      </div>
   

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


          <li class="nav-item">
            <a href="{!! url ('Dashboard_admin')!!}" class="nav-link @yield('dashboard_atv')">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Dashboard
                {{-- <span class="badge badge-info right">2</span> --}}
              </p>
            </a>
          </li>

         
          <?php 
            if(session()->get('userlogin')->Role =="ADMIN")
            {
              ?>
                <li class="nav-item @yield('menu_master')">
                  {{-- menu-open --}}
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                      Master
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{!! url('master_product'); !!}" class="nav-link  @yield('masterproduct_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Master Product</p>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="{!! url('master_affiliate'); !!}" class="nav-link  @yield('masteraffiliate_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Master Affiliate</p>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="{!! url('master_ebook'); !!}" class="nav-link  @yield('masterebook_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Master Ebook</p>
                      </a>
                    </li>


                    <li class="nav-item">
                      <a href="{!! url('master_promo'); !!}" class="nav-link  @yield('masterpromo_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Master Promo</p>
                      </a>
                    </li>


                    <li class="nav-item">
                      <a href="{!! url('master_voucher'); !!}" class="nav-link  @yield('mastervoucher_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Master Voucher</p>
                      </a>
                    </li>


                    <li class="nav-item">
                      <a href="{!! url('master_category'); !!}" class="nav-link  @yield('mastercategory_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Master Category</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{!! url('master_sub_category'); !!}" class="nav-link  @yield('mastersubcategory_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Master Sub Category</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{!! url('master_brand'); !!}" class="nav-link  @yield('masterbrand_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Master Brand</p>
                      </a>
                    </li>
      
                    <li class="nav-item">
                      <a href="{!! url('master_type'); !!}" class="nav-link  @yield('mastertype_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Master Type</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{!! url('master_supplier'); !!}" class="nav-link  @yield('mastersupplier_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Master Supplier</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{!! url('master_team_member'); !!}" class="nav-link  @yield('masterteammember_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Master Team Member</p>
                      </a>
                    </li>
                    
                    <li class="nav-item">
                      <a href="{!! url('master_bank'); !!}" class="nav-link  @yield('masterbank_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Master Bank</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./index2.html" class="nav-link ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard v2</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./index3.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard v3</p>
                      </a>
                    </li>
                  </ul>
                </li>
              
                <li class="nav-item @yield('menu_purchase')">
                  {{-- menu-open --}}
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-shopping-basket"></i>
                    <p>
                      Purchase
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{!! url ('Purchase')!!}" class="nav-link  @yield('purchase_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Order</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{!! url('Receive_request'); !!}" class="nav-link  @yield('receive_req_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Receive Request</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{!! url('Receive_order'); !!}" class="nav-link  @yield('receive_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Receive Order</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{!! url('Purchase_payment'); !!}" class="nav-link  @yield('purchasepayment_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Payment</p>
                      </a>
                    </li>
                 
                    
                  </ul>
                </li>
      
                <li class="nav-item @yield('menu_profile')">
                  {{-- menu-open --}}
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-desktop"></i>
                    <p>
                      Profile website
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{!! url ('master_banner')!!}" class="nav-link  @yield('banner_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Banner</p>
                      </a>
                    </li>
                  
                 
                    
                  </ul>
                </li>
                

              <?php 
            }
          ?>

        <?php 
        if(session()->get('userlogin')->Role =="SHIPPER")
        {
          ?>
          <li class="nav-item @yield('menu_purchase')">
            {{-- menu-open --}}
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-basket"></i>
              <p>
                Purchase
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <li class="nav-item">
                <a href="{!! url('Receive_order'); !!}" class="nav-link  @yield('receive_atv')">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Receive Order</p>
                </a>
              </li>
             
              
            </ul>
          </li>

          <li class="nav-item @yield('menu_Cust_order')">
            {{-- menu-open --}}
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-bell"></i>
              <p>
                Cust order
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <li class="nav-item">
                <a href="{!! url('Pick_order_shipper'); !!}" class="nav-link  @yield('cust_order_atv')">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cust order</p>
                </a>
              </li>
             
              
            </ul>
          </li>
         
        <?php 
         }
        ?>

        <?php 
        if(session()->get('userlogin')->Role =="CUSTOMER SERVICE" || session()->get('userlogin')->Role =="ADMIN")
        {
          ?>
          <li class="nav-item @yield('menu_master')">
            {{-- menu-open --}}
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-basket"></i>
              <p>
                Assist
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <li class="nav-item">
                <a href="{!! url('chat_list'); !!}" class="nav-link  @yield('live_chat_atv')">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Live Chat</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{!! url('list_request_assist'); !!}" class="nav-link  @yield('request_assist_atv')">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Request Assists</p>
                </a>
              </li>
              {{-- <li class="nav-item">
                <a href="{!! url('followup_customers'); !!}" class="nav-link  @yield('followup_customers_atv')">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Follow Up Customer</p>
                </a>
              </li>
              --}}
              
            </ul>
          </li>
          <li class="nav-item @yield('menu_master')">
            {{-- menu-open --}}
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-basket"></i>
              <p>
                Follow Up
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <?php 
              if(session()->get('userlogin')->Role =="CUSTOMER SERVICE")
              {
                ?>
                <li class="nav-item">
                  <a href="{!! url('list_available_customer'); !!}" class="nav-link  @yield('list_available_customer_atv')">
                    <i class="far fa-circle nav-icon"></i>
                    <p>List Available Customer</p>
                  </a>
                </li>
                <?php 
              }

              ?>

              <?php 
                  if(session()->get('userlogin')->Role =="ADMIN")
                  {
                    ?>
                    <li class="nav-item">
                      <a href="{!! url('pengaturan_followup'); !!}" class="nav-link  @yield('pengaturan_followup_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pengaturan Follow up</p>
                      </a>
                    </li>
                  
                <?php 
                }
              ?>
              <?php 
                  if(session()->get('userlogin')->Role =="CUSTOMER SERVICE")
                  {
                    ?>
                    <li class="nav-item">
                      <a href="{!! url('my_followup'); !!}" class="nav-link  @yield('my_followup_atv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>My Follow up</p>
                      </a>
                    </li>
                  
                <?php 
                }
              ?>
            </ul>
          </li>
         
        <?php 
         }
        ?>



<?php 
if(session()->get('userlogin')->Role =="ADMIN")
{
  ?>
    {{-- <li class="nav-item">
      <a href="{!! url('broadcast-view') !!}" class="nav-link  @yield('menu_broadcast')">
        <i class="nav-icon fas fa-broadcast-tower"></i>
        <p>
          Broadcast 
        </p>
      </a>
    </li> --}}

    <li class="nav-item @yield('menu_broadcast')">
      {{-- menu-open --}}
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-broadcast-tower"></i>
        <p>
          Broadcast 
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{!! url('broadcast-view'); !!}" class="nav-link  @yield('menu_broadcast_prospek')">
            <i class="far fa-circle nav-icon"></i>
            <p>Broadcast prospect E-book</p>
          </a>
        </li>
        
      </ul>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{!! url('broadcast-pembeli-view'); !!}" class="nav-link  @yield('menu_broadcast_pembeli')">
            <i class="far fa-circle nav-icon"></i>
            <p>Broadcast Pembeli</p>
          </a>
        </li>
        
      </ul>
    </li>
    <li class="nav-item @yield('menu_report')">
      {{-- menu-open --}}
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>
          Report 
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{!! url('stock_card'); !!}" class="nav-link  @yield('stockcard_atv')">
            <i class="far fa-circle nav-icon"></i>
            <p>Stock Card</p>
          </a>
        </li>
        
      </ul>
      
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{!! url('followup_report'); !!}" class="nav-link  @yield('followup_report_atv')">
            <i class="far fa-circle nav-icon"></i>
            <p>Follow Up</p>
          </a>
        </li>
        
      </ul>
    </li>
    
      <?php 
    }
    ?>
<?php 
if(session()->get('userlogin')->Role =="ADMIN" || session()->get('userlogin')->Role =="CUSTOMER SERVICE")
{
  ?>
    
    <li class="nav-item @yield('menu_kelola_database')">
      {{-- menu-open --}}
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-broadcast-tower"></i>
        <p>
          Kelola
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{!! url('database_pembeli'); !!}" class="nav-link  @yield('menu_database_pembeli_atv')">
            <i class="far fa-circle nav-icon"></i>
            <p>Database Pembeli</p>
          </a>
        </li>
        
      </ul>
    </li>
      <?php 
    }
    ?>
          
          
          {{-- <li class="nav-item">
            <a href="{!! url ('Purchase')!!}" class="nav-link @yield('purchase_atv')">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Purchase
                {{-- <span class="badge badge-info right">2</span> --}}
              {{-- </p>
            </a>
          </li>
           --}}
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
