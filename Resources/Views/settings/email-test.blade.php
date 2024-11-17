<script type="module">
    nsExtraComponents.nsEmailTestSettings = defineComponent({
        props: ['parent'],
        template: `<ns-button type="info" @click="testEmail()">${__m( 'Test Email', 'NsEmail' )}</ns-button>`,
        mounted() {
            // this.parent.loadSettingsForm() : use this to refresh the form.
        },
        methods: {
            testEmail() {
                Popup.show( nsPromptPopup, {
                    title: __m( 'Test Email', 'NsEmail' ),
                    input: `{{ Auth::user()->email }}`,
                    type: 'input',
                    message: __m( 'Please enter the email address to send the test email.', 'NsEmail' ),
                    onAction: ( email ) => {
                        if ( email.length > 0 ) {
                            // let's validate the email
                            // using regex
                            if ( !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test( email ) ) {
                                nsNotice.error(
                                    __m( 'Invalid Email', 'NsEmail' ),
                                    __m( 'Please enter a valid email address.', 'NsEmail' )
                                );
                                return;
                            }

                            const popup     =   Popup.show( nsPOSLoadingPopup );

                            nsHttpClient.post( '/api/nsemail/test', { email: email } ).subscribe({
                                next: ( response ) => {
                                    popup.close();

                                    if ( response.status === 'success' ) {
                                        nsNotice.success( __m( 'Email Queued', 'NsEmail' ), response.message );
                                    } else {
                                        nsNotice.error( __m( 'An Error Occured', 'NsEmail' ), response.message );
                                    }
                                },
                                error: ( error ) => {
                                    popup.close();
                                    nsNotice.error(
                                        __m( 'An Error Occured', 'NsEmail' ),
                                        __m( 'An error occured while sending the test email. Double-check your settings and try again.', 'NsEmail' )
                                    )
                                }
                            });
                        }
                    }
                })
            }
        }
    });
</script>