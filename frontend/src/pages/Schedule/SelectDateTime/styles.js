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
      height: 60px;
      padding: 20px;
      border-radius: 4px;
      background: #fff; 
      cursor: pointer;
    }
  }
`
