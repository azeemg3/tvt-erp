<table width="100%" style="border-top:1px solid #ccc; font-size:8px; color:#555; font-family: DejaVu Sans, sans-serif;">
    <tr>
        <td width="34%" style="text-align:left; border:none; padding-top:4px;">
            Copyright &copy; {{ date('Y') }} {{ $company->name }}.
        </td>
        <td width="32%" style="text-align:center; border:none; padding-top:4px;">
            @if(!empty($company->website))Website: {{ $company->website }}@endif
        </td>
        <td width="34%" style="text-align:right; border:none; padding-top:4px;">
            {{ $company->powered_by ?: 'All rights reserved.' }}
        </td>
    </tr>
</table>
