<form action="https://{{ $pfHost }}/eng/process" method="post">
    @csrf
    <div class="hidden">
    @foreach($data as $name => $value)
        @if(!in_array($name, ['id', 'login_time','email','created_at','updated_at','payment_status'])) <!-- Adjust the field names as necessary -->
            <input type="text" name="{{ $name }}" value="{{ $value }}">
        @endif
    @endforeach
    </div>

    <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
        <i class="fa-brands fa-cc-mastercard"></i>  Pay Now <i class="fa-brands fa-cc-visa"></i>
    </button>
</form>
