import React from 'react';
import Button from '@material-ui/core/Button';
import ChevronLeft from '@material-ui/icons/ChevronLeft';
import ChevronRight from '@material-ui/icons/ChevronRight';
import Toolbar from '@material-ui/core/Toolbar';
import MyUrlField from "./MyUrlField";

const Pagination = ({ page, perPage, total, setPage }) => {
    const nbPages = Math.ceil(total / perPage) || 1;
    return (
        nbPages > 1 &&
        <Toolbar>
            {page > 1 &&
            <Button color="primary" key="prev" icon={<ChevronLeft />} onClick={() => setPage(page - 1)}>
                Prev
            </Button>
            }
            {page !== nbPages &&
            <Button color="primary" key="next" icon={<ChevronRight />} onClick={() => setPage(page + 1)} labelPosition="before">
                Next
            </Button>
            }
        </Toolbar>
    );
}

export default Pagination;
