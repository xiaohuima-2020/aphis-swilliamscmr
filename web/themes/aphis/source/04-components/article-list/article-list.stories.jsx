import parse from 'html-react-parser';

import twigTemplate from './article-list.twig';
import data from './article-list.yml';

const settings = {
  title: 'Components/Article List',
  argTypes: {
    
  }

};

const ArticleList = args =>
  parse(
    twigTemplate({
      ...args,
    })
  );
ArticleList.args = { ...data };

export default settings;
export { ArticleList };
