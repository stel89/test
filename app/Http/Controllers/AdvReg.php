<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\ConfirmUsers;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\User;
Use Auth;

class AdvReg extends Controller
{
    public function register(Request $request) //Переделка стандартной регистрации 
{
	
	$this->validate($request, [
		'name' => 'required|unique:users|max:150',
		'email' => 'required|unique:users|max:250|unique:confirm_users|email',
		'password' => 'required|confirmed|min:6',
	]);
	
	//Создаем пользователя
	$user=User::create([
		'name' => $request->input('name'),
		'email' => $request->input('email'),
		'password' => bcrypt($request->input('password')),
	]);

	if($user) //Если юзер создан добавляем его данные в ConfirmUsers
	{
		$email=$user->email;  //это email, который ввел пользователь
		$token=str_random(32); //это наша случайная строка
		$model=new ConfirmUsers; //создаем экземпляр нашей модели
		$model->email=$email; //вставляем в таблицу email
		$model->token=$token; //вставляем в таблицу токен
		$model->save();      // сохраняем все данные в таблицу
		//отправляем ссылку с токеном пользователю
		Mail::send('emails.registration',['token'=>$token],function($u) use ($user)
		{
			$u->from('admin@site.ru');
			$u->to($user->email);
			$u->subject('Confirm registration');
		});
		//Немного читерю вставляя ссылку сюда на всякий случай 
	return back()->with('message','Спасибо за реггистрацию посмотрите на почте письмо подтверждения');
	}
	else {
		//Если что то пошло не так и $user не существует
		return redirect('/')->with('message','Беда с базой, попробуй позже');
	}
}

	public function confirm($token) //Подтверждение 
	{
		$model=ConfirmUsers::where('token','=',$token)->firstOrFail(); //выбираем запись с переданным токеном, если такого нет то будет ошибка 404
		$user=User::where('email','=',$model->email)->first(); //выбираем пользователя почта которого соответствует переданному токену
		$user->status=1; // меняем статус на 1
		$user->save();  // сохраняем изменения
		$model->delete(); //Удаляем запись из confirm_users
		Auth::login($user); //Авторизируем и перенаправляем на курс валют
	return redirect('/home')->with('message','Спасибо Вы теперь активированы');
	}
	
}
