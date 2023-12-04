@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-9 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách công thức</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Chọn</th>
                                    <th>STT</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Thành phần công thức</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $one)
                                <tr>
                                    <td></td>
                                    <td><input type="checkbox" name="" id="" value="{{$one->id_recipe}}"></td>
                                    <td>{{$key + 1}}</td>
                                    @foreach($listProduct as $key => $product)
                                    @if($product->id_product == $one->id_product)
                                    <td 
                                        class="id-product-{{$one->id_recipe}}" 
                                        data-id="{{$one->id_product}}"
                                    >
                                        {{$product->name_product}}
                                    </td>
                                    @endif
                                    @endforeach
                                    <td class="component-{{$one->id_recipe}}" data-count="{{count(json_decode($one->component_recipe))}}">
                                    @foreach(json_decode($one->component_recipe) as $key => $recipe)
                                        @php
                                            $ingredientName = '';
                                            $idIngredient = '';
                                            $unitName = '';
                                            $idUnit = '';
                                            $abbreviationUnit = '';
                                        @endphp

                                        @foreach($listIngredients as $ingredient)
                                            @if($ingredient->id_ingredient == $recipe->id_ingredient)
                                                @php
                                                    $ingredientName = $ingredient->name_ingredient;
                                                    $idIngredient = $recipe->id_ingredient;
                                                @endphp
                                            @endif
                                        @endforeach

                                        @foreach($listUnits as $unit)
                                            @if($unit->id_unit == $recipe->id_unit)
                                                @php
                                                    $unitName = $unit->fullname_unit;
                                                    $abbreviationUnit = $unit->abbreviation_unit;
                                                    $idUnit = $recipe->id_unit;
                                                @endphp
                                            @endif
                                        @endforeach
                                        <div class="my-2 {{$key > 0 ? 'border-top border-info ' : ''}}">
                                        </div>
                                        Nguyên liệu: <span class="id-ingredient-{{$one->id_recipe}}-{{$key}}" data-id="{{$idIngredient}}">{{ $ingredientName }}</span><br>
                                        Đơn vị: <span class="id-unit-{{$one->id_recipe}}-{{$key}}" data-id="{{$idUnit}}">{{ $unitName }}</span><br>
                                        Số lượng cần: <span class="quantity-recipe-{{$one->id_recipe}}-{{$key}}">{{$recipe->quantity_recipe_need}} </span>{{$abbreviationUnit}}<br>
                                    @endforeach
                                    </td>
                                    <td>
                                        <button class="btn btn-primary d-block mb-2 choose-recipe" data-id="{{$one->id_recipe}}" data-toggle="modal" data-target="#updateModal"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button class="btn btn-primary d-block mb-2 check-recipe" data-id="{{$one->id_recipe}}" ><i class="fa-solid fa-check"></i></button>
                                        <button class="btn btn-danger d-block delete-recipe" data-id="{{$one->id_recipe}}"><i class="fa-solid fa-trash-can"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-3 ">
                <div class="card">
                    <h5 class="card-header">Thao tác chung</h5>
                    <div class="card-body">
                        <button class="btn btn-primary d-block mb-3 w-100" data-toggle="modal" data-target="#exampleModal">Thêm công thức</button>
                        <button disabled class="w-100 disabled btn btn-primary delete-all delete-all-recipe d-block mb-3">Xóa nhiều</button>
                        <button class="w-100 btn btn-primary choose-all d-block">Chọn nhiều</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Insert -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm công thức</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <select name="id_product" id="name" class="form-control id-product">
                                    @foreach($listProduct as $key => $one)
                                    <option 
                                        value="{{$one->id_product}}" 
                                        class="form-control"
                                    >
                                        {{$one->name_product}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="option">Thành phần công thức</label>
                        <div class="row">
                            <div class="text-center btn btn-success add-component-recipe pe-auto w-25 mr-3" style="margin-left: 12px; cursor: pointer;">Thêm thành phần</div>
                            <div class="text-center btn btn-success remove-component-recipe pe-auto w-25" style="cursor: pointer;">Xóa cái cuối cùng</div>
                        </div>
                        <div class="form-component-recipe row mt-3">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary insert-recipe">Thêm</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Insert -->

    <!-- Modal Update -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sửa công thức</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_recipe" class="id-recipe">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <select name="id_product" id="name" class="form-control id-product-recipe">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="option">Thành phần công thức</label>
                        <div class="row">
                            <div class="text-center btn btn-success add-component-recipe-update pe-auto w-25 mr-3" style="margin-left: 12px; cursor: pointer;">Thêm thành phần</div>
                            <div class="text-center btn btn-success remove-component-recipe-update pe-auto w-25" style="cursor: pointer;">Xóa cái cuối cùng</div>
                        </div>
                        <div class="form-update-component-recipe row mt-3">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary update-recipe">Sửa</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Insert -->

    <!-- End of Main Content -->

</div>
@endsection