import React from 'react'
import { useSelector } from "react-redux";
import { Form } from '@unform/web';

import Input from "~/components/Form";

import { Wrapper, Content } from '../styles'

import close from '~/assets/close.svg'
import logo from '~/assets/calendar.svg'

const SignIn = props => {
  const loading = useSelector(state => state.auth.loading);

  return (
    <Wrapper>
      <Content>
        <span>
          <img src={close} alt='close' onClick={props.handleClose} />
          <span><img src={logo} alt='logo' /></span>
        </span>
        <Form onSubmit={props.handleSubmit}>
          <span className='inputs'>
            <Input name='login' placeholder='Nome de usuário ou e-mail' />
            <Input name='password' type='password' placeholder='Sua senha' />
          </span>
          <span className='buttons'>
            <button type='button' className='purple' onClick={props.handleSignup}>Criar uma conta</button>
            <button type='submit' className='green'>{ loading ? 'Carregando...' : 'Login' }</button>
          </span>
        </Form>
      </Content>
    </Wrapper>
  )
}

export default SignIn
