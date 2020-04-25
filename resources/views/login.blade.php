@include('includes/head')
@if( isset($_POST) )
  @if( $_POST["user"]=="b" && $_POST["password"]=="b" )
    <?php $_SESSION["logged_in"] = 1; ?>
    @include('content/home_page_content')
  @else
    Login incorrecto
    @include('content/login_content')
  @endif
@else
  @include('content/login_content')
@endif
@include('includes/bottom')
