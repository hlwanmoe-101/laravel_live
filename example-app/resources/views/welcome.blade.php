<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Javascript Test</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mt-5">
                   <div class="card-body">
                       <form action="{{route('fruit.store')}}" id="fruitForm" method="post" enctype="multipart/form-data">
                           @csrf
                           <div class="row">
                               <div class="col-3">
                                   <input type="file" name="photo" class="form-control">
                               </div>
                               <div class="col-3">
                                   <input type="text" name="name" class="form-control">
                               </div>
                               <div class="col-3">
                                   <input type="number" name="price" class="form-control">
                               </div>
                               <div class="col-3">
                                   <button class="btn btn-primary">
                                       <span class="spinner-grow spinner-grow-sm d-none btn-loader"></span>
                                       Add Fruit
                                   </button>
                               </div>
                           </div>
                       </form>
                       <div class="mt-5">
                           <table class="table table-bordered table-hover">
                               <thead>
                               <tr>
                                   <th>id</th>
                                   <th>Fruit</th>
                                   <th>Price</th>
                                   <th>Photo</th>
                                   <th>Control</th>
                                   <th>Created At</th>
                               </tr>
                               </thead>
                               <tbody id="rows">
                               @foreach(\App\Models\Fruit::all() as $fruit)

                                   <tr id="row{{$fruit->id}}">
                                       <th>{{$fruit->id}}</th>
                                       <th>{{$fruit->name}}</th>
                                       <th>{{$fruit->price}}</th>
                                       <th>
                                           <a class="venobox" href="{{asset('storage/photo/'.$fruit->photo)}}" >
                                               <img src="{{asset('storage/thumbnail/'.$fruit->photo)}}" width="50 " alt="image alt"/>
                                           </a>
                                       </th>
                                       <th>
                                           <div class="btn-group">
                                               <button class="btn btn-sm btn-outline-primary" onclick="del({{$fruit->id}})">
                                                   <i class="fas fa-trash-alt fa-fw"></i>
                                               </button>
                                               <button class="btn btn-sm btn-outline-primary" onclick="edit({{$fruit->id}})">
                                                   <i class="fas fa-pen-alt fa-fw"></i>
                                               </button>
                                           </div>

                                       </th>
                                       <th>{{$fruit->created_at->diffForHumans()}}</th>

                                   </tr>

                               @endforeach
                               </tbody>
                           </table>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editBox" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleBoxLabel">Edit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="editForm" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <img src="" id="editImg" class="w-50 d-block mx-auto" alt="">
                        <button type="button" class="btn btn-outline-primary camera">
                            <i class="fas fa-camera"></i>
                        </button>
                        <input type="file" name="photo" id="editPhoto" class="form-control d-none">
                        <input type="text" name="name" id="editName" class="form-control">
                        <input type="text" name="price" id="editPrice" class="form-control">

                    </form>

                </div>
                <div class="modal-footer">
                    <button form="editForm" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

<script src="{{asset('js/app.js')}}"></script>

    <script>
        new VenoBox({
            selector: '.venobox'
        });
        // let fruitForm=$("#fruitForm");
        // fruitForm.on("submit",function (e) {
        //     e.preventDefault();
        //
        //     $.post($(this).attr("action"),$(this).serialize(),function (data) {
        //         if(data.status=="success"){
        //             Swal.fire({
        //                 icon: 'success',
        //                 title: 'Data Insert Successful',
        //                 text: 'Aung p',
        //             })
        //         }else{
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: 'Validation Fail',
        //                 text: 'Wrong',
        //             })
        //         }
        //     })
        //
        // });

        let row=document.getElementById("rows");

        let btnLoaderUi=document.querySelector('.btn-loader');

        let editphoto=document.querySelector("#editPhoto");

        let fruitForm=document.querySelector("#fruitForm");
        fruitForm.addEventListener("submit",function (e) {
            e.preventDefault();
            btnLoaderUi.classList.toggle("d-none");
            let formdata=new FormData(this);
            axios.post(fruitForm.getAttribute("action"),formdata).then(function (response) {
                if(response.data.status == "success")
                {

                    let info=response.data.info;
                    let tr=document.createElement('tr');
                    tr.setAttribute("id","row"+info.id);
                    tr.classList.add("animate__animated","animate__slideInDown");
                    tr.innerHTML=`
                        <td>${info.id}</td>
                        <td>${info.name}</td>
                        <td>${info.price}</td>
                        <td>
                            <a class="venobox" href="${info.original_photo}">
                                <img src="${info.thumbnail_photo}" width="50 " alt="image alt"/>
                            </a>
                        </td>
                        <td>
                            <div class="btn-group">
                               <button class="btn btn-sm btn-outline-primary" onclick="del(${info.id})">
                                   <i class="fas fa-trash-alt fa-fw"></i>
                               </button>
                               <button class="btn btn-sm btn-outline-primary" onclick="edit(${info.id})">
                                   <i class="fas fa-pen-alt fa-fw"></i>
                               </button>
                            </div>
                        </td>
                        <td>${info.time}</td>
                        `;
                    row.append(tr);
                    fruitForm.reset();

                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Fail',
                        text: 'Wrong',
                    })
                }
                btnLoaderUi.classList.toggle("d-none");
            })
        })
        function del(id) {
            // alert(id);
            axios.delete("fruit/"+id).then(function (response) {
                if(response.data.status="success"){
                    Toast.fire({
                        icon: 'success',
                        title: 'Delete successfully'
                    })
                    document.getElementById("row"+id).remove();
                }
            })

        }
        let currentModal=new bootstrap.Modal(document.getElementById("editBox"),{backdrop:"static"}) ;
        function edit(id) {

            axios.get("fruit/"+id).then(function (response) {
                // console.log(response.data);
                let info=response.data;
                document.getElementById("editName").value=info.name;
                document.getElementById("editPrice").value=info.price;
                document.getElementById("editForm").setAttribute("data-id",id);
                document.getElementById("editImg").src=info.original_photo;


                currentModal.show();
            })
        }

        document.getElementById("editForm").addEventListener("submit",function (e) {
            e.preventDefault();
            // console.log("edit");
            let aa=new FormData(this);
            // console.log(aa.get("name"));
            let id=this.getAttribute("data-id");
            axios.post("fruit/"+id,aa).then(function (response) {
                console.log(response.data);
                if(response.data.status=="success"){
                    Toast.fire({
                        icon: 'success',
                        title: 'Update successfully'
                    })
                    currentModal.hide();
                    let info=response.data.info;
                    let tr=document.getElementById('row'+id);
                    tr.classList.add("animate__animated","animate__slideInDown");
                    tr.innerHTML=`
                        <td>${info.id}</td>
                        <td>${info.name}</td>
                        <td>${info.price}</td>
                        <td>
                            <a class="venobox" href="${info.original_photo}">
                                <img src="${info.thumbnail_photo}" width="50 " alt="image alt"/>
                            </a>
                        </td>
                        <td>
                            <div class="btn-group">
                               <button class="btn btn-sm btn-outline-primary" onclick="del(${info.id})">
                                   <i class="fas fa-trash-alt fa-fw"></i>
                               </button>
                               <button class="btn btn-sm btn-outline-primary" onclick="edit(${info.id})">
                                   <i class="fas fa-pen-alt fa-fw"></i>
                               </button>
                            </div>
                        </td>
                        <td>${info.time}</td>
                        `;
                }

            })

        })
        document.querySelector('.camera').addEventListener('click',function () {
            editphoto.click();
        })
        editphoto.addEventListener('change',function () {
            let currentPhoto=editphoto.files[0];
            filereader=new FileReader();
            filereader.onload=function (e) {
                document.getElementById('editImg').src=e.target.result;
            }
            filereader.readAsDataURL(currentPhoto);
        })

    </script>
</body>
</html>
