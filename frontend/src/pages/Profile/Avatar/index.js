import React, { useState, useRef, useEffect } from 'react'
import { useField } from "@unform/core";

import api from '~/services/api';

import { Container } from './styles'

import avatar from '~/assets/profile.png'

const Avatar = () => {
  const { defaultValue, registerField } = useField('avatar');

  const [file, setFile] = useState(defaultValue && defaultValue.id);
  const [preview, setPreview] = useState(defaultValue && defaultValue.url);

  const ref = useRef();

  useEffect(() => {
    if (ref.current) {
      registerField({
        name: 'avatar_id',
        ref: ref.current,
        path: 'dataset.file'
      });
    }
  }, [ref, registerField])

  async function handleChange (e) {
    const data = new FormData();

    data.append('image', e.target.files[0]);

    const response = await api.post('files', data);
    const { id, url } = response.data;

    setFile(id);
    setPreview(url);
  }

  return (
    <Container>
      <label htmlFor='avatar'>
        <img src={preview || avatar } alt='Foto de perfil' />
        <input
          type='file'
          id='avatar'
          accept='image/*'
          data-file={file}
          onChange={handleChange}
          ref={ref}
        />
      </label>
    </Container>
  )
}

export default Avatar
