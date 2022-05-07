<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCoalItem extends Mailable
{
    use SerializesModels;

    protected $html = '<html lang="pl"><body>Nowe dostępne przedmioty w sklepie</body></html>';

    public function build(): void
    {

    }
}
