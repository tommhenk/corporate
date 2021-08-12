<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Arr;
use Validator;

use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackMail;

class ContactsController extends SiteController
{
        public function __construct () {
        parent::__construct( new \App\Repositories\MenusRepository(new \App\Models\Menu) );

        $this->template = config('settings.theme').'.contacts.contacts';
        $this->bar = 'left';

    }

    public function index ( Request $request ) {

        if($request->isMethod('post')) {
            $input = $request->except('_token');

            $validator = Validator::make($input, [
                'name'=>'required|max:255',
                'email'=>'required|email',
                'text'=>'required'
            ]);

            if ($validator->fails()) {
                return redirect()->route('contacts')->withErrors($validator);
            }

            Mail::to(env('MAIL_USERNAME'))->send(new FeedbackMail($input));
            return redirect()->route('contacts')->with('status', 'email is send');
        }

        $this->tilte = 'contact';

        $content = view(config('settings.theme').'.contacts.contact_content')->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        $this->contentLeftBar = view(config('settings.theme').'.contacts.contact_bar')->render();

        return $this->renderOutput();
    }
}
