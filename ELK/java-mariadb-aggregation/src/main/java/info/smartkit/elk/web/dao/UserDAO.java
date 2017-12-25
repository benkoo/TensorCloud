package info.smartkit.elk.web.dao;

import info.smartkit.elk.web.domain.User;
import org.springframework.data.repository.CrudRepository;
import org.springframework.stereotype.Repository;

/**
 * An interface declaration in order to perform CRUD operations for {@link User} resource
 *
 * @author vlotar
 */
@Repository
public interface UserDAO extends CrudRepository<User, Long> {

}
