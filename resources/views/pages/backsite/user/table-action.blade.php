<a href="{{ route('backsite.user.show', $id) }}"
    class="inline-block border border-teal-500 bg-teal-500 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-teal-600 focus:outline-none focus:shadow-outline">
    <i class="fas fa-fw fa-eye"></i>
</a>
<a href="{{ route('backsite.user.edit', $id) }}"
    class="inline-block border border-indigo-500 bg-indigo-500 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline">
    <i class="fas fa-fw fa-edit"></i>
</a>
<form class="inline-block" action="{{ route('backsite.user.destroy', $id) }}" method="POST"
    onsubmit="return confirm('Are you sure to delete this user?');">
    @csrf
    @method('DELETE')
    <button type="submit"
        class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline">
        <i class="fas fa-fw fa-trash-alt"></i>
    </button>
</form>