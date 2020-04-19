import React from "react";
import { Form, Input, Check } from "@rocketseat/unform";

import { Wrapper, Content } from "../styles";

import close from "~/assets/close.svg";
import logo from "~/assets/calendar.svg";

const SignUp = props => {
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
                    <Input name="firstName" placeholder="Nome"/>
                    <Input name="lastName" placeholder="Sobrenome"/>
                    <Input name="userName" placeholder="Nome de usuário"/>
                    <Input name="email" type="email" placeholder="Seu e-mail"/>
                    <Input name="password" type="password" placeholder="Sua senha"/>
                    <Input name="rePassword" type="password" placeholder="Repita sua senha"/>
                    <label><Check name="check"/>Cadastrar-se como prestador?</label>
                    <span>
                        <button type="button" className="purple" onClick={() => props.login()}>Tem uma conta? Faça Login</button>
                        <button type="submit" className="green">Cadastrar-se</button>
                    </span>
                </Form>
            </Content>
        </Wrapper>
    );
};

export default SignUp;
