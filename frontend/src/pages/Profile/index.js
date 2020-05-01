import React from 'react'
import { Form } from '@unform/web';

import { Container } from './styles'
import Input from "~/components/Form";

import Avatar from './Avatar'
import { useSelector } from "react-redux";

const Profile = () => {
  const profile = useSelector(state => state.user.profile);

  function handleSubmit(data) {
    console.tron.log(data)
  }

  return (
    <Container>
      <Form initialData={profile} onSubmit={handleSubmit}>
        <Avatar name='avatar_id' />
        <Input name='user_name' placeholder='Nome de usuário' />
        <Input name='first_name' placeholder='Primeiro nome' />
        <Input name='last_name' placeholder='Sobrenome' />
        <Input name='email' type='email' placeholder='Seu e-mail' />

        <hr />

        <Input
          type='password'
          name='oldPassword'
          placeholder='Sua senha atual'
        />
        <Input type='password' name='password' placeholder='Sua nova senha' />
        <Input
          type='password'
          name='confirm'
          placeholder='Sua nova senha novamente'
        />

        <button type='submit'>Atualizar perfil</button>
      </Form>

      <button type='button'>Desconectar-se</button>
    </Container>
  )
}

export default Profile
