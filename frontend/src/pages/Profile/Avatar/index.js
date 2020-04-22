import React from 'react'

import { Container } from './styles'

import avatar from '~/assets/calendar.png'

const Avatar = () => {
  function handleChange (e) {}

  return (
    <Container>
      <label htmlFor='avatar'>
        <img src={avatar} alt='Foto de perfil' />

        <input
          type='file'
          id='avatar'
          accept='image/*'
          onChange={handleChange}
        />
      </label>
    </Container>
  )
}

export default Avatar
