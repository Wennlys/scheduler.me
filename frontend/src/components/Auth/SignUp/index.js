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
                    <img src={close} alt="close" onClick={props.close} />
                    <span><img src={logo} alt="logo" /></span>
                </span>
                <Form onSubmit={props.submit}>
                    <Input name="first_name" placeholder="Nome"/>
                    <Input name="last_name" placeholder="Sobrenome"/>
                    <Input name="user_name" placeholder="Nome de usuário"/>
                    <Input name="email" type="email" placeholder="Seu e-mail"/>
                    <Input name="password" type="password" placeholder="Sua senha"/>
                    <label><Check name="provider"/>Cadastrar-se como prestador?</label>
                    <span>
                        <button type="button" className="purple" onClick={props.login}>Tem uma conta?<br/>Faça Login</button>
                        <button type="submit" className="green">Cadastrar-se</button>
                    </span>
                </Form>
            </Content>
        </Wrapper>
    );
};

export default SignUp;
