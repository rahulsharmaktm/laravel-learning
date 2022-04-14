<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      All Category
    </h2>
  </x-slot>
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{session('success')}}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

          @endif
          <div class="card-header">Category</div>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">SL No</th>
                <th scope="col">Category</th>
                <th scope="col">User Name</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>

              @foreach($categories as $category)
              <tr>
                <th scope="row">{{$categories->firstItem()+$loop->index}}</th>
                <td> {{$category->category_name}} </td>
                <td>{{$category->user->name}}</td>
                <td>
                  @if($category->created_at == NULL)
                  <span class="text-danger">No Date set</span>
                  @else
                  {{Carbon\Carbon::parse($category->created_at)->diffForHumans()}}
                  @endif
                </td>
                <td>
                  <a href=" {{ url('category/edit/'.$category->id)}} " class="btn btn-info">Edit</a>
                  <a href="{{url('softDelete/category/'.$category->id)}}" class="btn btn-danger">Delete</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

          {{$categories->links()}}
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Add Category</div>
          <div class="card-body">
            <form action=" {{route('store.category')}} " method="POST">
              @csrf
              <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="category_name" class="form-control">
                @error('category_name')
                <span class="text-danger">{{$message}}</span>
                @enderror

              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>



    <!-- TRACH DATA START  -->
    <div class="row mt-4">
      <div class="col-md-8">
        <div class="card p-2">

          <div class="card-header">Trach Category</div>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">SL No</th>
                <th scope="col">Category</th>
                <th scope="col">User Name</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>

              @foreach($trachCat as $category)
              <tr>
                <th scope="row">{{$categories->firstItem()+$loop->index}}</th>
                <td> {{$category->category_name}} </td>
                <td>{{$category->user->name}}</td>
                <td>
                  @if($category->created_at == NULL)
                  <span class="text-danger">No Date set</span>
                  @else
                  {{Carbon\Carbon::parse($category->created_at)->diffForHumans()}}
                  @endif
                </td>
                <td>
                  <a href=" {{ url('category/restore/'.$category->id)}} " class="btn btn-info">Restore</a>

                  <a href="{{ url('category/pdelete/'.$category->id)}}" class="btn btn-danger">Delete</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

          {{$trachCat->links()}}
        </div>
      </div>
      <div class="col-md4">

      </div>

    </div>
  </div>
</x-app-layout>