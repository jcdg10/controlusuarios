@section('header')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script> 
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


@stop
@include('../layout.header')

@include('../layout.sidebar')

@section('content')

<div class="row">
  <div class="col-lg-6"></div>
  <div class="col-lg-6"><button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#agregarProductoModal">Agregar producto</button></div>
</div>
<br>
<table class="table table-bordered table-hover" id="data-table">
  <thead>
      <tr>
          <th>No</th>
          <th>Name</th>
          <th>Price</th>      
          <th></th>            
      </tr>
  </thead>
  <tbody>
  </tbody>
</table>

@stop
@include('../layout.body')

@include('../layout.footer')
@include('../layout.js')


@include('../layout.datatablejs')

<!-- Agregar Modal -->
<div class="modal fade" id="agregarProductoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" method="POST" id="agregarProducto">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row">
                <div class="col-lg-12">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" />
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-12">
                    <label for="nombre">Precio:</label>
                    <input type="number" class="form-control" id="precio" name="precio" />
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="guardarProducto">Guardar</button>
      </div>
    </div>
    </form>
  </div>
</div>


<!-- Editar Modal -->
<div class="modal fade" id="editarProductoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" method="POST" id="editarProducto">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row">
                <div class="col-lg-12">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombreProductoEdit" name="nombreProductoEdit" />
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-12">
                    <label for="nombre">Precio:</label>
                    <input type="number" class="form-control" id="precioEdit" name="precioEdit" />
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="idProductoEdit" name="idProductoEdit" />
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="modificarProducto">Modificar</button>
      </div>
    </div>
    </form>
  </div>
</div>

<script type="text/javascript">
  let table;
  $(function () {
     
    table = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/products",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'price', name: 'price'},
            {data: 'action', name: 'action'},          
        ]
    });
     
  });

  $("#guardarProducto").click(function(){

    let nombre = $("#nombreProducto").val();
    let precio = $("#precio").val();
        $.ajax({
            type: "POST",
            data: { nombre: nombre, 
                    precio : precio,
                    "_token": "{{ csrf_token() }}" },
            dataType: 'JSON',
            url: "/product",
            success: function(msg){ 
              if(msg == '1'){
                table.ajax.reload();
                $("#agregarProductoModal").modal('hide');
              }
              if(msg == '0'){
                alert('Ocurrio un error');
              }
            }
        }); 
  });
  
  $(document).on("click", ".eliminar", function(){
    let id = this.id;

    $.ajax({
        type: "DELETE",
        dataType: 'JSON',
        data: { "_token": "{{ csrf_token() }}" },
        url: "/product/" + id,
        success: function(msg){ 
          if(msg == '1'){
            table.ajax.reload();
          }
          if(msg == '0'){
            alert('Ocurrio un error');
          }
        }
    }); 
    
  });

  $(document).on("click", ".editar", function(){
    let id = this.id;

      $.ajax({
          type: "GET",
          dataType: 'JSON',
          data: { "_token": "{{ csrf_token() }}" },
          url: "/product/" + id,
          success: function(msg){ 
            //console.log(msg);
            $("#nombreProductoEdit").val(msg.name);
            $("#precioEdit").val(msg.price);
            $("#idProductoEdit").val(msg.id);
            $("#editarProductoModal").modal("show");
            
          }
      }); 
    
    });

    $("#modificarProducto").click(function(){

          let nombre = $("#nombreProductoEdit").val();
          let precio = $("#precioEdit").val();
          let id = $("#idProductoEdit").val();
              $.ajax({
                  type: "PUT",
                  data: { nombre: nombre, 
                          precio : precio,
                          "_token": "{{ csrf_token() }}" },
                  dataType: 'JSON',
                  url: "/product/" + id,
                  success: function(msg){ 
                    if(msg == '1'){
                      table.ajax.reload();
                      $("#editarProductoModal").modal('hide');
                    }
                    if(msg == '0'){
                      alert('Ocurrio un error');
                    }
                  }
              }); 
          });
</script>