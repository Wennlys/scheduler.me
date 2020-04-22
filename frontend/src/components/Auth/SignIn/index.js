import React from 'react'
import { Form, Input } from '@rocketseat/unform'
import * as Yup from 'yup';

import { Wrapper, Content } from '../styles'

import close from '~/assets/close.svg'
import logo from '~/assets/calendar.svg'

const schema = Yup.object().shape({
  login: Yup.string().required('Forneça o seu login'),
  password: Yup.string().required('Forneça a sua senha')
});

const SignIn = props => {
  return (
    <Wrapper>
      <Content>
        <span>
          <img src={close} alt='close' onClick={props.handleClose} />
          <span><img src={logo} alt='logo' /></span>
        </span>
        <Form schema={schema} onSubmit={props.handleSubmit}>
          <span className='inputs'>
            <Input name='login' placeholder='Nome de usuário ou e-mail' />
            <Input name='password' type='password' placeholder='Sua senha' />
          </span>
          <span className='buttons'>
            <button type='button' className='purple' onClick={props.handleSignup}>Criar uma conta</button>
            <button type='submit' className='green'>Login</button>
          </span>
        </Form>
      </Content>
    </Wrapper>
  )
}

export default SignIn
