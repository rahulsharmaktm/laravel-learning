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
                    <div class="card-header">Update Category</div>
                    <div class="card-body">
                        <form action=" {{url('category/update/'.$categories_edit->id)}} " method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Update Cagegory Name</label>

                                <input type="text" name="category_name" class="form-control" value="{{$categories_edit->category_name}}">
                                @error('category_name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>