<div class="flex justify-center">
    <nav aria-label="Page navigation example">
        <ul class="flex list-style-none">
            @if ($pagination['present'] !== 1)
                <li class="page-item disabled">
                    <a class="page-link relative block py-1.5 px-3 rounded border-0 bg-transparent outline-none transition-all duration-300 rounded text-gray-500 hover:text-gray-800 hover:bg-gray-200 focus:shadow-none"
                        href="{{ $pagination['url'] }}{{ $pagination['present'] - 1 }}">Previous</a>
                </li>
                <li class="page-item">
                    <a class="page-link relative block py-1.5 px-3 rounded border-0 bg-transparent outline-none transition-all duration-300 rounded text-gray-800 hover:text-gray-800 hover:bg-gray-200 focus:shadow-none"
                        href="{{ $pagination['url'] }}{{ $pagination['present'] - 1 }}">{{ $pagination['present'] - 1 }}</a>
                </li>
            @endif

            <li class="page-item active">
                <a
                    class="page-link relative block py-1.5 px-3 rounded border-0 bg-gray-600 outline-none transition-all duration-300 rounded text-white hover:text-white shadow-md focus:shadow-md">{{ $pagination['present'] }}<span
                        class="visually-hidden"></span></a>
            </li>

            @if ($pagination['present'] !== $pagination['pageNum'])
                <li class="page-item">
                    <a class="page-link relative block py-1.5 px-3 rounded border-0 bg-transparent outline-none transition-all duration-300 rounded text-gray-800 hover:text-gray-800 hover:bg-gray-200 focus:shadow-none"
                        href="{{ $pagination['url'] }}{{ $pagination['present'] + 1 }}">{{ $pagination['present'] + 1 }}</a>
                </li>
                <li class="page-item">
                    <a class="page-link relative block py-1.5 px-3 rounded border-0 bg-transparent outline-none transition-all duration-300 rounded text-gray-800 hover:text-gray-800 hover:bg-gray-200 focus:shadow-none"
                        href="{{ $pagination['url'] }}{{ $pagination['present'] + 1 }}">Next</a>
                </li>
            @endif
        </ul>
    </nav>
</div>
