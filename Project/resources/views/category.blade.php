<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Categories_Task</title>

        <!-- W3School -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <!-- End of W3School  -->
         
        <!-- Bootstrap CDN -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
        <!-- End of Bootstrap CDN -->


        

       
    </head>
   
    <body>
     
    
      <div class="row">

          {{-- Tha part of Add category && Selector --}}
          <div class="col">
            <form class="container p-3 my-3 border" method="POST" action="{{route('categories.store')}}"> 
                
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="POST">

                <div class="input-group mb-3 " >
                    <div class="input-group-prepend">
                      <button style="background-color:#343a40; color:white " class="btn btn-outline-secondary" type="submit">Add Category</button>
                    </div>
                    <input type="text" name="name" class="form-control" placeholder="New Category" aria-label="" aria-describedby="basic-addon1">
                </div>
                  
                <select style="border-width: 2px;" class="form-select form-select-lg mb-3 " name="category_id" aria-label=".form-select-lg example">
                  @if($Allcategories != null)
                    @foreach($Allcategories as $index => $category)

                      @if($index == 0){<option  value= {{Null}} >Select The Parent Category</option>} @endif

                      <option value={{$category->id}} >{{$category->name}}</option>

                    @endforeach
                  
                  @else
                   <option >EMPTY</option>

                  @endif
                </select>
              
            </form>

            {{-- End the part --}}
            
              {{-- Tha part of Search --}}
              <div class="border" style="padding: 1em 250px; margin-top: 50px" class="col-md-10">
                <form action="{{ route('categories.index') }}" method="get">
                <input  type="text" name="search" class="form-control" placeholder="search" value="{{ request()->search }}">
                <button  type="submit" class="btn btn-primary">
                  {{-- the icon of search --}}
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="10  " fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                  </svg>
                  {{-- End of icon --}}
                </button>
                </form>
              </div>
              {{-- End the part --}}
          

            {{-- Tha part of Table --}}
            <table  class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">action</th>
                    <th scope="col">id</th>
                    <th scope="col">category name</th>
                    <th scope="col">category_id</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($Allcategories as $index => $category)
                      <tr>
                        @if($category->category_id == Null) {{$category->category_id == "Null"}} @endif
                        <th scope="row">
                          <form method="POST" action="{{route('categories.destroy',$category->id)}}"> 

                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="Delete">
                          <button class=" btn-danger" type="submit" > Delete</button>

                          </form>
                        </th>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->category_id}}</td>
                      </tr>

                    @endforeach
                
                </tbody>
            </table>
            {{-- End the part --}}
            

            {{-- Tha part of Pagination --}}
            {{ $Allcategories->appends(request()->query())->links() }}
            {{-- End the part --}}
              
          </div>
                
        {{-- Tha part of Tree View --}}
        <div class="col">
                <div style="font-size: 20px" class="container-lg p-3 my-3 border">
                  <ul>
                      @foreach ($categories as $category)
                          <li>{{ $category->name }}</li>
                          <ul>
                          @foreach ($category->childrenCategories as $childCategory)
                              @include('child_category', ['child_category' => $childCategory])
                          @endforeach
                          </ul>
                      @endforeach
                  </ul>

                </div>     
        </div>
        {{-- End the part --}}
      </div>
    
  </body>
</html>
