@extends('emails.template')
@section('emails.main')
<h3 style="text-align:center;font-weight: bold;">{{ $site_name }}</h3>
<p>Hi {{ @$first_name }},</p>
<p>
  This is reply for your message regarding a property.<br>
  <a href="{{ $url.('/properties/'.$token) }}">view property listing page </a>
</p>
<table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
  <tbody>
    <tr>
      <td align="center">
        <table border="0" cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
              <td>Your Message: {{ $chat_receive }} </td>
            </tr>
            <tr>
              <td>Reply From Property Manager: {{ $chat_reply }} </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
@stop

