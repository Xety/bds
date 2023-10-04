@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img src="{{ asset('images/logos/selvah_570x350.png') }}" class="logo" alt="Selvah Logo">
            <span class="title">{{ $slot }}</span>
        </a>
    </td>
</tr>
