import React, { useState } from 'react';

import { Navigation } from './styles';
import Notifications from "~/components/Header/Notification";
import { Link } from "react-router-dom";
const Menu = () => {
  const [read, setRead] = useState(false);

  return (
    <Navigation unread={read}>
        <div id="menuToggle">
          <input type="checkbox"/>
          <div className="badge" />
          <span/>
          <span/>
          <span/>
          <ul id="menu">
              <li><Notifications isRead={setRead}/></li>
              <Link to='/profile'><li>Perfil</li></Link>
              <Link to='/dashboard'><li>Agenda</li></Link>
              <a href='/'><li className='last'>Desconectar-se</li></a>
          </ul>
        </div>
    </Navigation>
  );
};

export default Menu;
