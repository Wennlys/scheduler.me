import React, { useState } from 'react'
import { useDispatch } from "react-redux";
import { Link } from 'react-router-dom'

import { Wrapper, Content } from './styles'

import logo from '~/assets/logo.svg'
import homeImage from '~/assets/home-image.svg'
import SignIn from '~/components/Auth/SignIn'
import SignUp from '~/components/Auth/SignUp'

import { signInRequest, signUpRequest } from "~/store/modules/auth/actions";

const Home = () => {
  const [iframe, setIframe] = useState(false);
  const dispatch = useDispatch();

  function handleClose () {
    setIframe(false)
  }

  function handleSignInSubmit ({ login, password }) {
    dispatch(signInRequest(login, password));
  }

  function handleSignUpSubmit ({ user_name, first_name, last_name, email, password, provider }) {
    dispatch(signUpRequest(user_name, first_name, last_name, email, password, provider));
    handleSignInClick();
  }

  function handleSignInClick () {
    setIframe(<SignIn handleClose={handleClose} handleSubmit={handleSignInSubmit} handleSignup={handleSignUpClick} />)
  }

  function handleSignUpClick () {
    setIframe(<SignUp handleClose={handleClose} handleSubmit={handleSignUpSubmit} handleLogin={handleSignInClick} />)
  }

  return (
    <Wrapper>
      <Content disable={iframe}>
        <nav>
          <Link to='/'>
            <img src={logo} alt='logo' />
          </Link>
          <aside>
            <button type='button' onClick={handleSignInClick}>
                            Fazer Login
            </button>
            <button type='button' onClick={handleSignUpClick}>
                            Cadastrar-se
            </button>
          </aside>
        </nav>
        {iframe}
        <div className='container'>
          <img src={homeImage} alt='Home' />
          <span>
            <strong>Agende um horário com nossos prestadores</strong>
            <button type='button' onClick={handleSignUpClick}>
                            Agendar Agora
            </button>
          </span>
        </div>
      </Content>
    </Wrapper>
  )
}

export default Home
