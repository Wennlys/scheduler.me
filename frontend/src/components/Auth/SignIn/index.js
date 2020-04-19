import React from "react";
import { Form, Input } from "@rocketseat/unform";

import { Wrapper, Content } from "../styles";

import close from "~/assets/close.svg";
import logo from "~/assets/calendar.svg";

const SignIn = props => {
    return (
        <Wrapper>
            <Content>
                <span>
                <button type="button" onClick={() => props.close()}>
                    <img src={close} alt="close" />
                </button>
                    <span><img src={logo} alt="logo" /></span>
                </span>
                <Form onSubmit={() => props.submit()}>
                    <span className="inputs">
                        <Input name="userName" placeholder="Nome de usuário ou e-mail"/>
                        <Input name="password" type="password" placeholder="Sua senha"/>
                    </span>
                    <span className="buttons">
                        <button type="button" className="purple" onClick={() => props.signup()}>Criar uma conta</button>
                        <button type="submit" className="green">Login</button>
                    </span>
                </Form>
            </Content>
        </Wrapper>
    );
};

export default SignIn;
