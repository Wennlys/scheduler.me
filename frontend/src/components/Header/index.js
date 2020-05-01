import React from 'react'
import { Link } from "react-router-dom";

import logo from '~/assets/calendar.svg'
import profile from '~/assets/profile.png'

import { Container, Content, Profile } from './styles'
import Menu from "~/components/Header/Menu";

const Header = () => {
  return (
    <Container>
      <Content unread>
          <Link to='/profile'>
            <Profile>
              <img src={profile} alt='Wennlys Oliveira' />
              <hr />
              <div>Wennlys Oliveira</div>
            </Profile>
          </Link>
        <Link to='/dashboard'>
          <img src={logo} alt='logo' />
        </Link>
        <Menu />
      </Content>
    </Container>
  )
}

export default Header
