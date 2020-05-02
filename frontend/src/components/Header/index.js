import React from 'react'
import { Link } from "react-router-dom";
import { useSelector } from "react-redux";

import history from "~/services/history";

import logo from '~/assets/calendar.svg'

import { Container, Content, Profile } from './styles'
import Menu from "~/components/Header/Menu";

const Header = () => {
  const profile = useSelector(state => state.user.profile);

  return (
    <Container>
      <Content>
          <Link to='/profile'>
            <Profile>
              <img src={profile.avatar.url} alt='Wennlys Oliveira' />
              <hr />
              <div>{profile.first_name + " " + profile.last_name}</div>
            </Profile>
          </Link>
        <Menu provider={profile.provider} />
      </Content>
        <img src={logo} alt='logo' onClick={() => history.push('/dashboard')} />
    </Container>
  )
}

export default Header
