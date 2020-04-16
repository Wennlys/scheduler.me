import React from "react";
import PropTypes from "prop-types";

import { Wrapper, Nav } from "./styles";

const HomeLayout = ({ children }) => {
    return (
        <Wrapper>
            <Nav>{children}</Nav>
        </Wrapper>
    );
};

HomeLayout.propTypes = {
    children: PropTypes.element.isRequired
};

export default HomeLayout;
