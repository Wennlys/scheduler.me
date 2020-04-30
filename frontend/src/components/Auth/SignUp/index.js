import React, { useState } from 'react'
import { Form } from '@unform/web';

import { Wrapper, Content } from '../styles'

import Input from "~/components/Form";

import close from '~/assets/close.svg'
import logo from '~/assets/calendar.svg'


const SignUp = props => {
  const [checkbox, setCheckbox] = useState(false);
   return (
    <Wrapper>
      <Content>
        <span>
          <img src={close} alt='close' onClick={props.handleClose} />
          <span><img src={logo} alt='logo' /></span>
        </span>
        <Form onSubmit={props.handleSubmit}>
          <span className='inputs'>
          <Input name='first_name' placeholder='Nome' />
          <Input name='last_name' placeholder='Sobrenome' />
          <Input name='user_name' placeholder='Nome de usuário' />
          <Input name='email' type='email' placeholder='Seu e-mail' />
          <Input name='password' type='password' placeholder='Sua senha' />
          <label><Input name='provider' type='checkbox' onClick={() => setCheckbox(!checkbox)} value={checkbox}/>Cadastrar-se como prestador?</label>
          </span>
          <span className="buttons">
            <button type='button' className='purple' onClick={props.handleLogin}>Tem uma conta?<br />Faça Login</button>
            <button type='submit' className='green'>Cadastrar-se</button>
          </span>
        </Form>
      </Content>
    </Wrapper>
  )
}

export default SignUp
