import React, { useState } from 'react';
import { Link } from "react-router-dom";
import { useDispatch } from "react-redux";

import { signOut } from "~/store/modules/auth/actions";

import { Navigation } from './styles';
import Notifications from "~/components/Header/Notification";

const Menu = props => {
  const dispatch = useDispatch();
  const [read, setRead] = useState(false);

  function handleSignOut() {
    dispatch(signOut());
  }

  return (
    <Navigation unread={ read }>
      <div id="menuToggle">
        <input type="checkbox"/>
        <div className="badge"/>
        <span/>
        <span/>
        <span/>
        <ul id="menu">
          { props.provider ? <li><Notifications isRead={ setRead }/></li> : (
            <Link to="/schedule">
              <li>Agendar</li>
            </Link>
          )}
          <Link to='/dashboard'>
            <li>Sua agenda</li>
          </Link>
          <Link to='/profile'>
            <li>Perfil</li>
          </Link>
          <Link to='/'>
            <li className='last' onClick={handleSignOut}>Desconectar-se</li>
          </Link>
        </ul>
      </div>
    </Navigation>
  );
};

export default Menu;
