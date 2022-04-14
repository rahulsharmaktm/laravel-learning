<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Brand
        </h2>
    </x-slot>
    <div class="container mt-4">
        <div class="row">

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update Brand</div>
                    <div class="card-body">
                        <form action=" {{url('brands/update/'.$brands->id)}} " method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Update Brand Name</label>

                                <input type="text" name="brand_name" class="form-control" value="{{$brands->brand_name}}">
                                <label class="form-label mt-3">Update Brand Imgae</label>

                                <input type="file" name="brand_image" class="form-control" value="{{$brands->brand_image}}">
                                @error('brand_image')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <img src="{{asset($brands->brand_image)}}" alt="" style="width:400px; height:200px;">
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Update Brand</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>