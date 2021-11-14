<link href="{{ asset ('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<script src ="{{ asset ('js/jquery.js') }}"></script>
<script src ="{{ asset ('js/bootstrap.js') }}"></script>



{{-- <link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
 --}}





<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">


<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Pusat Herbal Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        {{-- <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{!! url('master_product'); !!}">Master product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{!! url('master_category'); !!}">Master category</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{!! url('master_sub_category'); !!}">Master sub category</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{!! url('master_team_member'); !!}">Master Team Member</a>
        </li> --}}

       
        {{-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle"  id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="true">
            Master
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{!! url('master_product'); !!}">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li> --}}
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Master 
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{!! url('master_product'); !!}">Master Product</a>
            <a class="dropdown-item" href="{!! url('master_brand'); !!}">Master Brand</a>
            <a class="dropdown-item" href="{!! url('master_type'); !!}">Master Type</a>
            <a class="dropdown-item" href="{!! url('master_category'); !!}">Master Category</a>
            <a class="dropdown-item" href="{!! url('master_sub_category'); !!}">Master Sub Category</a>
            <a class="dropdown-item" href="{!! url('master_team_member'); !!}">Master Team Member</a>
            <a class="dropdown-item" href="{!! url('master_supplier'); !!}">Master Supplier</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{!! url('logout'); !!}">Log Out</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

@yield('isi')



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script> 