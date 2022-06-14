<form action="{{ route('order_placement') }}" method="POST">
    @csrf
    <input type="hidden" name="sales_id" value="1">
    <input type="hidden" name="no_of_productss" value="1">
    <input type="hidden" name="channel_number" value="1">
    <input type="hidden" name="machine_number" value="machine-123">
    <button type='submit'>order</button>

</form>