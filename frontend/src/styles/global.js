import { createGlobalStyle } from 'styled-components'

import 'react-toastify/dist/ReactToastify.css';
import 'react-perfect-scrollbar/dist/css/styles.css';

export default createGlobalStyle`
  
  *{  
    margin: 0;
    padding: 0;
    outline: 0;
    box-sizing: border-box;
    
    ::-moz-focus-inner {
        border: 0;
    }
  }
  
  *:focus {
    outline: 0;
  }
  
  html, body, #root {
    height: 100%;
  }
  
  body {
   -webkit-font-smoothing: antialiased;
  }
  
  body, input, button {
    font-family: 'Montserrat', sans-serif;
  }
  
  a {
    text-decoration: none;
  }
  
  ul {
    list-style: none;
  }
  
  button {
    cursor: pointer;
  }
`
