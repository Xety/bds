@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img src="{{ asset('images/logos/cbds_324x383.png') }}" class="logo" alt="{{ config('bds.info.full_name') }} Logo">
            <span class="title">{{ $slot }}</span>
        </a>
    </td>
</tr>
