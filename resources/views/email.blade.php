<!doctype html>
<html>
@include('post-office::assets.header')

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
                                        @isset($greeting)
                                            <p>{{ $greeting  }},</p>
                                        @endisset

                                        {{-- Messages --}}
                                        @foreach($messages as $message)
                                            <p>{{ $message }}</p>
                                        @endforeach

                                        {{-- Call to action --}}
                                        @includeWhen(! is_null($call_to_action), 'post-office::assets.call-to-action', $call_to_action)
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                {{-- Footer --}}
                @if(config('post-office.mailables.footer.enabled'))
                    <div class="footer">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="content-block">
                                    @if(config('post-office.mailables.footer.address'))
                                        <span class="apple-link">{{ config('post-office.mailables.footer.address') }}</span>
                                    @endif

                                    @if(config('post-office.mailables.footer.unsubscribe_route'))
                                        <br> Don't like these emails?
                                        <a href="{{ route(config('post-office.mailables.footer.unsubscribe_route'), ['email'=>$email]) }}">Unsubscribe</a>.
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                @endif
            </div>
        </td>
        <td></td>
    </tr>
</table>
</body>
</html>
