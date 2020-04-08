import React from "react";

import { Container } from "./styles";

import Avatar from "./Avatar";

const Profile = () => {
  return (
    <Container>
      <form>
        <Avatar name="avatar_id" />
        <input name="userName" placeholder="Nome de usuário" />
        <input name="name" placeholder="Primeiro nome" />
        <input name="name" placeholder="Sobrenome" />
        <input name="email" type="email" placeholder="Seu e-mail" />

        <hr />

        <input
          type="password"
          name="oldPassword"
          placeholder="Sua senha atual"
        />
        <input type="password" name="password" placeholder="Sua nova senha" />
        <input
          type="password"
          name="confirm"
          placeholder="Sua nova senha novamente"
        />

        <button type="submit">Atualizar perfil</button>
      </form>

      <button type="button">Desconectar-se</button>
    </Container>
  );
};

export default Profile;
