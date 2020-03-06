import React from "react";

import { Link } from "react-router-dom";
import logo from "~/assets/calendar.svg";

const SignIn = () => {
  return (
    <>
      <div>
        <img src={logo} alt="Scheduler" />
        <form>
          <input type="text" placeholder="Nome de usuário ou E-mail" />
          <input type="password" placeholder="Sua senha" />

          <button type="submit">Acessar</button>
          <Link to="/register-names">Criar uma conta gratuita</Link>
        </form>
      </div>
    </>
  );
};

export default SignIn;
