API described in usage.txt

The code consists of 4 layers:
    1) SsMailer\Model - describes the requests and responses and the way the are processed
    2) SsMailer\Json - describes how the requests and responses are represented in json.
    3) SsMailer\Http - describes how the json accepted from client and the response returned back through HTTP protocol.
    4) SsMailer\Applications - top level use cases encapsulating cooperation of the other layers.

The applications layer represents the 3 use cases of this API:
    1) SsMailer\Applications\Send - HTTP application that sends an email as described in usage.txt
    2) SsMailer\Applications\Cancel - HTTP application that cancels a delayed email by its ID as descibed in usage.txt
    3) SsMailer\Applications\Queue - CLI application that should be run with cron that delivers delayed emails.

The actual implementation of some key components is left unfinished, this include:
    1) SsMailer\Model\Send\PersisterInterface - responsible for persisting requests that are to be sent with delay
    2) SsMailer\Model\MailerInterface - responsible for actualy sending the emails to a mail server.
    3) SsMailer\Model\Cancel\CancelableRepositoryInterface - responsible for retrieving persisted requests so client can cancel them.
    4) SsMailer\Model\Queue\RepositoryInterface - responsible for retrieving formerly stored delayed emails that reached delay deadline.
