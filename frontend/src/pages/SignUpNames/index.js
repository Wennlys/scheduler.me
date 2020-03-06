import React from "react";

import { Link } from "react-router-dom";
import logo from "~/assets/calendar.svg";

const SignUpNames = () => {
  return (
    <>
      <div>
        <img src={logo} alt="Scheduler" />
        <form>
          <input placeholder="Nome de usuário" />
          <input placeholder="Seu nome" />
          <input placeholder="Seu sobrenome" />

          <button type="submit">
            <Link to="/register-info">Continuar o cadastro</Link>
          </button>
          <Link to="/">Já tenho uma conta</Link>
        </form>
      </div>
    </>
  );
};

export default SignUpNames;
