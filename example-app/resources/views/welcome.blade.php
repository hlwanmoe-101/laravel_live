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
                                   <button class="btn btn-primary">Add Fruit</button>
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
                               </tr>
                               </thead>
                               <tbody>
                               @foreach(\App\Models\Fruit::all() as $fruit)

                                   <tr>
                                       <th>{{$fruit->id}}</th>
                                       <th>{{$fruit->name}}</th>
                                       <th>{{$fruit->price}}</th>
                                       <th>
                                           <a class="venobox" href="{{asset('storage/photo/'.$fruit->photo)}}">
                                               <img src="{{asset('storage/thumbnail/'.$fruit->photo)}}" width="50 " alt="image alt"/>
                                           </a>
                                       </th>

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



<script src="{{asset('js/app.js')}}"></script>

    <script>

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

        let fruitForm=document.querySelector("#fruitForm");
        fruitForm.addEventListener("submit",function (e) {
            e.preventDefault();

            let formdata=new FormData(this);
            axios.post(fruitForm.getAttribute("action"),formdata).then(function (response) {
                if(response.data.status == "success")
                {
                    fruitForm.reset();

                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Fail',
                        text: 'Wrong',
                    })
                }
            })
        })
        new VenoBox({
            selector: '.venobox'
        });
    </script>
</body>
</html>
