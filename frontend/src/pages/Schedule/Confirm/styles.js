import styled from "styled-components";
import { darken } from 'polished';

export const Content = styled.div`
  display: flex;
  flex-direction: column;
  align-items: center;
  position: absolute;
  width: 200px;
  margin-top: 50px;
  
  img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 3px solid #fff;
    margin-bottom: 30px;
    background: #fff;
  }
  
   button {
     margin-top: 30px;
     padding: 15px;
     width: 300px;
     box-sizing: border-box;
     background: #8354b3;
     color: #fff;
     border: 0;
     border-radius: 4px;
     font-size: 16px;
     transition: background 0.2s;

     a {
         color: #fff;
     }

     &:hover {
         background: ${darken(0.05, '#8354B3')};
     }
   }
`
