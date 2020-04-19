import React, { useState } from "react";
import { Link } from "react-router-dom";

import { Wrapper, Content } from "./styles";

import logo from "~/assets/logo.svg";
import homeImage from "~/assets/home-image.svg";
import SignIn from "~/components/Auth/SignIn";
import SignUp from "~/components/Auth/SignUp";

const Home = () => {
    const [iframe, setIframe] = useState(false);

    function handleCloseClick() {
        setIframe(false);
    }

    function handleSubmit(data) {
        console.tron.log(data);
    }

    function handleSignUpClick() {
        setIframe(<SignUp close={handleCloseClick} submit={handleSubmit} login={handleSignInClick} />);
    }

    function handleSignInClick() {
        setIframe(<SignIn close={handleCloseClick} submit={handleSubmit} signup={handleSignUpClick}/>);
    }

    return (
        <Wrapper>
            <Content disable={iframe}>
                <nav>
                    <Link to="/">
                        <img src={logo} alt="logo" />
                    </Link>
                    <aside>
                        <button type="button" onClick={handleSignInClick}>
                            Fazer Login
                        </button>
                        <button type="button" onClick={handleSignUpClick}>
                            Cadastrar-se
                        </button>
                    </aside>
                </nav>
                {iframe}
                <div className="container">
                    <img src={homeImage} alt="Home" />
                    <span>
                        <strong>Agende um horário com nossos prestadores</strong>
                        <button type="button" onClick={handleSignUpClick}>
                            Agendar Agora
                        </button>
                    </span>
                </div>
            </Content>
        </Wrapper>
    );
};

export default Home;
