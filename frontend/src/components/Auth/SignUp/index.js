import React from 'react'
import { Form, Input, Check } from '@rocketseat/unform'
import * as Yup from 'yup';

import { Wrapper, Content } from '../styles'


import close from '~/assets/close.svg'
import logo from '~/assets/calendar.svg'

const schema = Yup.object().shape({
  first_name: Yup.string().required('Forneça o seu nome'),
  last_name: Yup.string().required('Forneça o seu Sobrenome'),
  user_name: Yup.string().required('Forneça o seu nome de usuário'),
  email: Yup.string().email('Forneça um e-mail válido').required('Forneça um e-mail'),
  password: Yup.string().required('Forneça a sua senha')
});

const SignUp = props => {
  return (
    <Wrapper>
      <Content>
        <span>
          <img src={close} alt='close' onClick={props.handleClose} />
          <span><img src={logo} alt='logo' /></span>
        </span>
        <Form schema={schema} onSubmit={props.handleSubmit}>
          <span className='inputs'>
          <Input name='first_name' placeholder='Nome' />
          <Input name='last_name' placeholder='Sobrenome' />
          <Input name='user_name' placeholder='Nome de usuário' />
          <Input name='email' type='email' placeholder='Seu e-mail' />
          <Input name='password' type='password' placeholder='Sua senha' />
          <label><Check name='provider' />Cadastrar-se como prestador?</label>
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
