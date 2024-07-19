<form action="{{ route('example.update',['example'=>1]) }}" method="post">
@csrf
@method('update')

<input type="submit" value="update"/>

</form>