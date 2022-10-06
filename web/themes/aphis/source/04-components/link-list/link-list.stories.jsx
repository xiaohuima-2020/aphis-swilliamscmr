import parse from 'html-react-parser';

import twigTemplate from './link-list.twig';
import data from './link-list.yml';

const settings = {
  title: 'Components/Link List'
};

const LinkList = args =>
  parse(
    twigTemplate({
      ...args,
    })
  );
LinkList.args = { ...data };

export default settings;
export { LinkList };
