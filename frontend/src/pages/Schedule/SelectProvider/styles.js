import styled from "styled-components";

export const Content = styled.div`
  position: absolute;
  margin-top: 30px;
  
  ul {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-gap: 15px;
    
    li {
      width: 200px;
      border-radius: 4px;
      background: #fff; 
      display: flex;
      flex-direction: column;
      justify-content: space-evenly;
      align-items: center;
      cursor: pointer;
      
      img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
      }
      
      strong {
        display: block;
        color: #000;
        font-size: 15px;
        font-weight: 500;
      }
    }
  }
`

