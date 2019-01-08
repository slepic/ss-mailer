SEND EMAIL:

Request:
POST /email/send
{
    to: "target@example.com", //string => comma separated list of valid email addresses; array => array of valid email addresses.
    cc: "copy@example.com", //----//----
    bcc: "bcc@example.com", //----//----
    from: "sender@example.com",
    subject: "email subject",
    body: "<div>Hello world.</div>",
    html: true,
    delay: "30 minutes",
    webhooks: { 
        success: "https://example.com/success",
        failure: "https://example.com/failure",
    }
}

Success Response:
HTTP 200 OK
{
    success: true,
    messageId: 123 //only delayed emails
}

Error Response:
HTTP 200 OK
{
    //Indicates error response
    success: false,

    //Object containing error messages with properties corresponding to request keys in which the error occured.
    //One exception is property "delivery" which is present when validations are ok but delivery of an immediate email fails.
    errors: {
        to: "At least one target email required.",
        subject: "Subject cannot be empty.",
        body: "Body cannot be empty.",
        delay: "Value not recognized.",
        success: "Success webhook not a valid url.",
        failure: "Failure webhook not a valid url.",
        delivery: "Could not deliver the email."
    }
}

CANCEL DELAYED EMAIL

Request:
GET /email/cancel/<messageId>

Success Response:
HTTP 200 OK
{
    success: true
}

Error Response:
HTTP 200 OK
{
    success: false,
    errors: {
       id: "Message id not found.",
       expired: "Message has already been sent."
    }
}

