<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>edit class</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
    rel="stylesheet">
  <style>
    * {
      font-family: "Lato", sans-serif;
    }
  </style>
</head>

<body>
  <main>
    <div class="container my-5">
      <div class="bg-light p-5 rounded">
        <h2 class="fw-bold fs-2 mb-5 pb-2">edit Class</h2>
        <form action="{{route('classes.update',$class->id)}}" method="post" class="px-md-5" enctype="multipart/form-data">
          @csrf
          @method('put')
          <div class="form-group mb-3 row">
            <label for="" class="form-label col-md-2 fw-bold text-md-end">classname</label>
            <div class="col-md-10">
              <input type="text" placeholder="" class="form-control py-2" name="classname" value="{{old('classname',$class->classname)}}" />
              @error('classname')
                  <div class="alert alert-warning">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group mb-3 row">
            <label for="" class="form-label col-md-2 fw-bold text-md-end">Price:</label>
            <div class="col-md-10">
              <input type="number" step="0.1" placeholder="Enter price" class="form-control py-2" name="price" value="{{old('price',$class->price)}}" />
              @error('price')
              <div class="alert alert-warning">{{$message}}</div>
             @enderror
            </div>
          </div>
          <hr>
          <div class="form-group mb-3 row">
            <label for="" class="form-label col-md-2 fw-bold text-md-end">capacity:</label>
            <div class="col-md-10">
              <input type="number" step="0.1" placeholder="" class="form-control py-2" name="capacity" value="{{old('capacity',$class->capacity)}}" />
              @error('capacity')
              <div class="alert alert-warning">{{$message}}</div>
          @enderror
            </div>
          </div>
          
          <hr>
          <div class="form-group mb-3 row">
            <label for="" class="form-label col-md-2 fw-bold text-md-end">isfilled:</label>
            <div class="col-md-10">
              <input type="hidden" value="0" name="isfilled">
              <input type="checkbox" class="form-check-input" style="padding: 0.7rem;" name="isfilled" value="1" @checked(old('isfilled',$class->isfilled))/>
              @error('isfilled')
              <div class="alert alert-warning">{{$message}}</div>
          @enderror
            </div>
          </div>
          <hr>
          <div class="time" style="margin-left: 100px">
            <label >Time from:</label>
            
              <input type="time"  name="timefrom" value="{{old('timefrom',$class->timefrom)}}" />
              @error('timefrom')
              <div class="alert alert-warning">{{$message}}</div>
              @enderror
           
          </div>

          <hr>
          <div class="time" style="margin-left: 100px">
            <label >Time to:</label>
              <input type="time"  name="timeto" value="{{old('timeto',$class->timeto)}}" />
              @error('timeto')
              <div class="alert alert-warning">{{$message}}</div>
          @enderror
           
          </div>
          
<hr>
          <div class="form-group" style="margin-left: 100px;">
            <label class="control-label col-sm-2" for="image">image:</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" id="image"  name="image" value="{{old('image')}}">
              
            </div>
          </div>

          <div class="text-md-end">
            <button class="btn mt-4 btn-secondary text-white fs-5 fw-bold border-0 py-2 px-md-5">
              edit class
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>