<!doctype html>
<html>
@include('post-office.assets.header')

<body class="">
<span class="preheader">{{ implode('  ', $messages) }}</span>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
    <tr>
        <td></td>
        <td class="container">
            <div class="content">
                <table role="presentation" class="main">
                    <tr>
                        <td class="wrapper">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        {{-- Greeting --}}
                                        <p>{{ $greeting  }},</p>

                                        {{-- Messages --}}
                                        @foreach($messages as $message)
                                            <p>{{ $message }}</p>
                                        @endforeach

                                        {{-- Call to action --}}
                                        @include('post-office.assets.call-to-action', $call_to_action)
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                {{-- Footer --}}
                {{-- todo: add conditional --}}
                <div class="footer">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="content-block">
                                <span class="apple-link">35 Main Street, Milford MA 01747</span>
                                <br> Don't like these emails?
{{--                                <a href="{{ route('public.contact.unsubscribe', ['email'=>$email]) }}">Unsubscribe</a>.--}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td></td>
    </tr>
</table>
</body>
</html>
