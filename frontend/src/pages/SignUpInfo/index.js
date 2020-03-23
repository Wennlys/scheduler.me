import React from "react";

import { Link } from "react-router-dom";
import logo from "~/assets/calendar.svg";

const SignUpInfo = () => {
  return (
    <>
      <div>
        <img src={logo} alt="Scheduler" />
        <form>
          <input type="email" placeholder="Seu e-mail" />
          <input type="password" placeholder="Sua senha" />
          <input type="password" placeholder="Reescreva sua senha" />
          <label htmlFor="checkbox">
            <input className="regular-checkbox" type="checkbox" />
            <div>SOU UM PRESTADOR DE SERVIÇOS</div>
          </label>

          <button type="submit">Cadastrar</button>
          <Link to="/">Já tenho uma conta</Link>
        </form>
      </div>
    </>
  );
};

export default SignUpInfo;
