import React from "react";
import { Link } from "react-router-dom";

import logo from "~/assets/logo.svg";
import homeImage from "~/assets/home-image.svg";

const Home = () => {
    return (
        <div>
            <nav>
                <Link to="/">
                    <img src={logo} alt="logo" />
                </Link>
                <aside>
                    <div>Fazer Login</div>
                    <fieldset>Cadastrar-se</fieldset>
                </aside>
            </nav>
            <div className="container">
                <img src={homeImage} alt="logo" />
                <span>
                    <strong>Agende um horário com nossos prestadores</strong>
                    <fieldset>Agendar Agora</fieldset>
                </span>
            </div>
        </div>
    );
};

export default Home;
